import { mapGetters } from 'vuex'
export default {
    props: ['userPermission'],

    data() {
        return {}
    },

    methods: {
        can(key) {
            let isPermitted = false;
            for (let d of this.userPermission2) {
                if (this.$route.name == d.screen_route) {
                    if (d.operation_id == key) {
                        isPermitted = true
                        break;
                    }
                }
            }
            return isPermitted
        },
    },

    computed: {
        ...mapGetters({
            'userPermission2': 'getUserPermission'
        }),
        cannew() {
            return this.can('1') //new
        },
        canupdate() {
            return this.can('2') //update
        },
        candelete() {
            return this.can('3') //delete
        }
    }
}