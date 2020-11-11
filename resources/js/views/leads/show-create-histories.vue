<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card" >
                <div class="card-panel p-2">

                    <div class="row">
                        <div class="col-md-12">
                            <update-lead-status :lead="getLead"> </update-lead-status>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
    import UpdateLeadStatus from "../../components/UpdateLeadStatus";
export default {
    components : {
        UpdateLeadStatus
    },
    computed : {
        ...mapGetters(['getLead', "getErrors"]),
    },
}
</script>
