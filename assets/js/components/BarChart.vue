<script>
import { Bar } from "vue-chartjs";

export default {
  extends: Bar,
  
  props: ['chart', 'options'],
  watch: {
    chart () {
      this.$data._chart.update()
    }},
  mounted() {
    this.renderChart(
      {
        labels: [
          "2014",
          "2015",
          "2016",
          "2017",
          "2018",
          "2019",
          "2020",
          
        ],
        datasets: [
          {
            label: "DISTSAUTOR1",
            backgroundColor: "#f87979",
            data: this.chart,
            stack: 2,
          },
          {
            label: "DISTSAUTOR2",
            backgroundColor: "#f88000",
            data: [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11],
            stack: 2,
          },
          {
            label: "DISTSAUTOR3",
            backgroundColor: "#f89000",
            data: [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11],
            stack: 2,
          },
          {
            label: "DISTSAR1",
            backgroundColor: "#f90000",
            data: [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11],
            stack: 2,
          }
        ],
      },
      
      { 
        plugins: {
            title: {
                display: true,
                text: 'Custom Chart Title'
            }
        },
        responsive: true,  
        scales: {
                  x: {
                    stacked: true,
                  },
                  y: {
                    stacked: true
                  }
        },
        maintainAspectRatio: false,
      }
  
        );
  }
};
</script>
