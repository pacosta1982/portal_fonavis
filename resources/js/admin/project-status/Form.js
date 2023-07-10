import AppForm from '../app-components/Form/AppForm';

Vue.component('project-status-form', {
    mixins: [AppForm],
    props: ["project","user","stages", "email"],
    data: function() {
        return {
            form: {
                project_id:  this.project,
                stage:  '' ,
                user_id:  this.user,
                record:  '' ,
                email: this.email,

            }
        }
    }

});
