<template>
    <div>
        <show-lead-status-history :lead="getLead"> </show-lead-status-history>
    </div>
</template>

<script>
import ShowLeadStatusHistory from "../../components/ShowLeadStatusHistory";
import {mapGetters} from "vuex";
export default {
    components : {
        ShowLeadStatusHistory
    },
    computed : {
        ...mapGetters(['getLead', "getErrors"]),
    },
}
</script>
