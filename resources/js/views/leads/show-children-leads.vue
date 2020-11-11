<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card" >
                <div class="card-panel p-2">
                    <div class="row">
                        <div class="col-md-12">
                            <lead-children :lead="getLead"> </lead-children>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import LeadChildren from "../../components/LeadChildren";
export default {
    components : {
        LeadChildren
    },
    computed : {
        ...mapGetters(['getLead', "getErrors"]),
    },
}
</script>
