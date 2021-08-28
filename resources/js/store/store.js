export default {
    state: {
        code_table: [],
        userPermission: []
    },
    getters: {
        getUserPermission(state) {
            return state.userPermission
        },
    },

    actions: {
        loaddictionary() {
            axios.get('api/dictionary').then(response => {
                Vue.i18n.add(default_locale_lang, response.data);
            });

            axios.get('api/userpermission').then(response => {
                this.state.userPermission = response.data;
            });
        },

        loaduserPermission() {
            axios.get('api/userpermission').then(response => {
                this.state.userPermission = response.data;
            });
        }
    }
}
