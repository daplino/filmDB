<template>
    <div>
        <h2 v-html='title'>Welcomehome</h2>
        <form @submit="formSubmit">
            <fieldset class="form-group border p-2 shadow-lg mb-5 rounded">
            <legend class="w-auto">Chart parameters</legend>
          
            <div class="form-group row">
                <label for="film_id" class="col-form-label col-lg-1 offset-lg-1">Action</label>   
                <select class="form-control col-lg-2" id="exampleFormControlSelect1" v-model="action" @change="onChange()">
                    <option></option>
                    
                    <option v-bind:value='{id: action, name: action}' v-for='action in actions' :key='action' >{{action}}</option>
                    
                    
                </select>
        
                <label for="film_id" class="col-form-label col-lg-1 ">Year</label>
                <select class="form-control col-lg-2" id="exampleFormControlSelect1" v-model.number="year">
                    <option></option>
                    <option value='2021'>2021</option>
                    <option>2020</option>
                </select>
                <label for="film_id" class="col-form-label col-lg-1 ">Round</label>
                <select class="form-control col-lg-2" id="exampleFormControlSelect1" v-model.number="round">
                    <option value='1'>1</option>
                    <option>2</option>
                </select>
            </div>
    </fieldset>
    
    
</form> 
<input type="checkbox" id="checkbox" v-model="checked">
    
    <BarChart :chart="data1"/>

    <br>

    </div>


</template>

<script>
import axios from 'axios';
import Vue from 'vue';
import Chart from 'vue-chartjs';
import BarChart from "../components/BarChart.vue";






export default {
    name: 'stats',
    components: {
      BarChart,
    },
    data: () => ({
        checked: false,
        queryResults: [],
        data1: [],
        title:'Statistics',
        actions:['DISTAUTOR1','DISTAUTOR2','DISTAUTOR3','DISTSAR1'],
        year: 2021,
        round: 1,
        output:'',
        id:0,
        query:""
    }),
     methods: {
        onChange(event) {
            axios.get('http://127.0.0.1:8000/en/handleStatsVue/'+this.query).then(response => {
                this.queryResults = response.data
                this.queryResults.forEach(el=>{
                    this.data1.push(parseInt(el.count,10));
                });
            });       
        },
        formSubmit(e) {
                e.preventDefault();
               
    },
    mounted() {
          
        }

}
}

</script>