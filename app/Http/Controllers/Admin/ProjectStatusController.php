<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectStatus\BulkDestroyProjectStatus;
use App\Http\Requests\Admin\ProjectStatus\DestroyProjectStatus;
use App\Http\Requests\Admin\ProjectStatus\IndexProjectStatus;
use App\Http\Requests\Admin\ProjectStatus\StoreProjectStatus;
use App\Http\Requests\Admin\ProjectStatus\UpdateProjectStatus;
use App\Models\ProjectStatus;
use App\Models\Project;
use App\Models\User;
use App\Models\Sat;
use App\Models\Distrito;
use App\Models\Departamento;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class ProjectStatusController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexProjectStatus $request
     * @return array|Factory|View
     */
    public function index(IndexProjectStatus $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(ProjectStatus::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'project_id', 'stage_id', 'user_id', 'record'],

            // set columns to searchIn
            ['id', 'record']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.project-status.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.project-status.create');

        return view('admin.project-status.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjectStatus $request
     * @return array|RedirectResponse|Redirector
     */

     public function store(StoreProjectStatus $request)
     {
         $sanitized = $request->getSanitized();
         $sanitized['stage_id'] = $request->getStageId();

         $projecto = Project::where('id', $request->project_id)->get();
         $sat = $projecto[0]->sat_id;
         $useremail = User::where('sat_ruc', $sat)->get()->first();
         $satnombre = Sat::where('NucCod', $sat)->get()->first();
         $toEmail = $useremail['email'];
         $ciudad = Distrito::where('CiuId', $projecto[0]->city_id)->first();
         $distrito = $ciudad->CiuNom;
         $departamento = Departamento::where('DptoId', $projecto[0]->state_id)->first();
         $dto = $departamento->DptoNom;


         if ($sanitized['stage_id'] == 2) {
             $subject = 'PROYECTO ' .$projecto[0]->name. ' PRESELECCIONADO';

             // Store the ProjectStatus
             $projectStatus = ProjectStatus::create($sanitized);

             try {
                 Mail::mailer('mail2')->send('admin.project-status.email', ['proyecto' => $projecto[0]->name ,'id' => $projecto[0]->id,'distrito' => $distrito,'dpto' => $dto], function ($message) use ($toEmail, $subject) {
                     $message->to($toEmail);
                     $message->subject($subject);
                     $message->from('preseleccionfonavis@muvh.gov.py', env('APP_NAME'));
                 });

                 return response()->json([
                     'redirect' => url('admin/projects/' . $request['project_id'] . '/show')
                 ]);
             } catch (Exception $e) {
                 // Si se produce un error al enviar el correo electrónico, devolvemos una respuesta JSON con un mensaje de error
                 return response()->json([
                     'error' => 'No se pudo enviar el correo electrónico'
                 ]);
             }
         } else {
             // Store the ProjectStatus
             $projectStatus = ProjectStatus::create($sanitized);

             return response()->json([
                 'redirect' => url('admin/projects/' . $request['project_id'] . '/show')
             ]);
         }

         return response()->json([
             'redirect' => url('admin/projects/' . $request['project_id'] . '/show')
         ]);
     }
    /**
     * Display the specified resource.
     *
     * @param ProjectStatus $projectStatus
     * @throws AuthorizationException
     * @return void
     */
    public function show(ProjectStatus $projectStatus)
    {
        $this->authorize('admin.project-status.show', $projectStatus);

        // TODO your code goes here
    }


    public function eliminar($projectStatus)
{
    ProjectStatus::where('project_id', $projectStatus)->delete();

    return redirect()->back()->with('success', 'El proyecto ha vuelto al estado Pendiente');
}
    /**
     * Show the form for editing the specified resource.
     *
     * @param ProjectStatus $projectStatus
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(ProjectStatus $projectStatus)
    {
        $this->authorize('admin.project-status.edit', $projectStatus);


        return view('admin.project-status.edit', [
            'projectStatus' => $projectStatus,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjectStatus $request
     * @param ProjectStatus $projectStatus
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateProjectStatus $request, ProjectStatus $projectStatus)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values ProjectStatus
        $projectStatus->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/project-statuses'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/project-statuses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyProjectStatus $request
     * @param ProjectStatus $projectStatus
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyProjectStatus $request, ProjectStatus $projectStatus)
    {
        $projectStatus->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyProjectStatus $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyProjectStatus $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    ProjectStatus::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
