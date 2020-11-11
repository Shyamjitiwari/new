// const state = {
//     userLeadStatusWise : [],
//     userLeadSourceWise : [],
// };

// const getters = {
//     getUserLeadStatusWise(state){
//         return state.userLeadStatusWise;
//     },
//     getUserLeadSourceWise(state){
//         return state.userLeadSourceWise;
//     }
    
// };

// const mutations = {
//     setUserLeadStatusWise(state, payload){
//         state.userLeadStatusWise = payload;
//     },
//     setUserLeadSourceWise(state, payload){
//         state.userLeadSourceWise = payload;
//     }
// };

// const actions = {
//     fetchUserLeadStatusWise(context, payload) {
//         console.log(payload);
//         this.dispatch("dispatch_request", {
//             method: "POST",
//             url: "user-lead-status-wise",
//             data : payload,
//             success_callback: function success_callback(response) {
//                 context.commit("setUserLeadStatusWise", response.data.data);
//             }
//         })
//     },
//     fetchUserLeadSourceWise(context, payload) {
//         console.log(payload);
//         this.dispatch("dispatch_request", {
//             method: "POST",
//             url: "user-lead-source-wise",
//             data : payload,
//             success_callback: function success_callback(response) {
//                 context.commit("setUserLeadSourceWise", response.data.data);
//             }
//         })
//     },
// };

// export default {
//     state,
//     getters,
//     mutations,
//     actions
// }
