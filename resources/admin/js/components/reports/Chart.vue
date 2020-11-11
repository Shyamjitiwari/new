<script>
import VueCharts from 'vue-chartjs'
import { Line, mixins } from 'vue-chartjs'
import { mapGetters } from "vuex";
export default {
  extends: Line,
  mixins: [mixins.reactiveProp],
  props: ['chartData'],
  data(){
      return{
          la : ['sp','ps','pp'],
          da : [1,2,3]
      }
  },

  mounted () {
    this.renderChart(this.chartData, {responsive: true, maintainAspectRatio: false})
  }
}
</script>
