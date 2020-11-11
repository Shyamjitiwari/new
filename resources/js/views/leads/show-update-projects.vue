<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card" >
                <div class="card-panel p-2">
                    <div class="row">
                        <div class="col-md-12">
                            <update-projects :lead="getLead"> </update-projects>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import UpdateProjects from "../../components/UpdateProjects";
export default {
    components : {
        UpdateProjects
    },
    computed : {
        ...mapGetters(['getLead', "getErrors"]),
    },
}
</script>
