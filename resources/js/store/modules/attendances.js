const state = {
    attendances: {},
   
};

const getters = {
    getUserAttendances(state){
        
        return state.attendances;
    },
  
};

const mutations = {
    setUserAttendances(state,payload){
        state.attendances = payload;
    },
   
};

const actions = {
    markUserAttendance(context,payload){
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "user-attendance-mark/",
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    markUserAttendanceByAdmin(context,payload){
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "attendance-mark-admin/",
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    markUserAbsentByAdmin(context, payload){
        this.dispatch("dispatch_request", {
            method: "POST",
            url: "mark-absent",
            data: payload,
            success_callback: function success_callback() {
                router.go(-1);
            }
        })
    },
    fetchUserAttendances(context,payload){
        console.log('pay'+payload.month);
        this.dispatch("dispatch_request", {
            method: "GET",
            url: "attendances?user=" +
            payload.user +
            "&month=" +
            payload.month,   
            success_callback: function success_callback(response) {
                context.commit("setUserAttendances", response.data.data);
            }
        })
    },
   
};

export default {
    state,
    getters,
    mutations,
    actions
};
