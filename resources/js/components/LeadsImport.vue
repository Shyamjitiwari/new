<template>
    <div>
        <form id="createLeadSource" @submit.prevent="importLeads" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="1">Import File (xlsx only)</label>
                        <input id="1" type="file" @change="getFile" ref="excel" name="excel" class="form-control" required>
                    </div>
                </div>
            </div>
            <submit-button status="Import"> </submit-button>
        </form>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import XLSX from 'xlsx';

export default {
    data(){
        return{
            rows : []
        }
    },
    computed: {
        ...mapGetters(["getErrors", "getMessage"]),
    },
    methods:{
        // getFile(e){
        //     var form = new FormData();
        //     this.file = this.$refs.excel.files[0];
        //     console.log(this.file);
        // },
        importLeads(){
            // console.log(this.$refs.file.files[0])
            this.$store.dispatch('dispatchLeadsImport', {rows: this.rows});
        },
        getFile(e){
            let _this = this;
            let files = e.target.files, f = files[0];
            let reader = new FileReader();
            reader.onload = function(e) {
                let data = new Uint8Array(e.target.result);
                let workbook = XLSX.read(data, {type: 'array'});
                let sheetName = workbook.SheetNames[0]
                /* DO SOMETHING WITH workbook HERE */
                console.log(workbook);
                let worksheet = workbook.Sheets[sheetName];
                console.log(XLSX.utils.sheet_to_json(worksheet));
                _this.rows = XLSX.utils.sheet_to_json(worksheet);
            };
            reader.readAsArrayBuffer(f);
        },
    }

}
</script>
