<template>
    <div>
        <h2 v-html='title'>Welcomehome</h2>
        <form @submit="formSubmit">
            <fieldset class="form-group border p-2 shadow-lg mb-5 rounded">
            <legend class="w-auto">Project n° </legend>
          
            <div class="form-group row">
                <label for="film_id" class="col-form-label col-lg-1 offset-lg-1">Action</label>   
                <select class="form-control col-lg-2" id="exampleFormControlSelect1" v-model="action" @change="onChange()">
                    <option></option>
                    <option value="DEVSLATE">DEVSLATE</option>
                    <option value="DEVSPANI">DEVSPANI</option>
                    <option value="DEVSPDOC">DEVSDOC</option>
                    <option value="DEVSPFIC">DEVSPFIC</option>
                    <option value="DISTAUTOG">DISTAUTOG</option>
                    <option value="DISTSAG">DISTSAG</option>
                    <option value="DISTAUTOR2">DISTAUTOR2</option>
                    <option>DISTSEL</option>
                    
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
    
    <fieldset class="form-group border p-2 shadow mb-5 rounded" >
    <legend class="w-auto">Statistics</legend>
     
         
            
         <table class='table'>
             <thead>
                <th>Id</th>
                <th>Activity Type</th>
                <th>Film</th>
                <th></th>
            </thead> 
			
            <tr v-for='element in activisions' :key="element.id">
                <td><input class="form-control" type="text" v-model="activisions.count"></td>
                <td><input class="form-control" type="text" v-model="element.count"></td>
                <td><input class="form-control" type="text" ></td>
                <td><a class="button is-primary">Add Movie</a></td>				
                
            </tr>
				
			
        </table>

 
	
    <br>
    <div class="result"><a id="result_'" class="btn btn-success single_result" href="#" hidden></a></div>
    </fieldset>
    
    
    <button class="btn btn-primary col-lg-2 offset-md-1 shadow-lg mb-5 rounded">Save Project</button>
    
</form> 
<input type="checkbox" id="checkbox" v-model="checked">
    
    <BarChart :chart="data1"/>

    <br>

    </div>


</template>

<script>
import axios from 'axios';
import Vue from 'vue';
import Vuex from 'vuex';
import Chart from 'vue-chartjs';
import BarChart from "../components/BarChart.vue";
import store from '../store';

import ActivityDistautog from "../components/ActivityDistautog.vue"





export default {
    name: 'stats',
    components: {
      ActivityDistautog,
      BarChart,
    },
    data: () => ({
        checked: false,
        activisions: [],
        data1: [],
        title:'test',
        action:"TEST",
        year: 2021,
        round: 1,
        output:'',
        id:0
    }),
     methods: {
        onChange(event) {
            axios.get('http://127.0.0.1:8000/en/handleStatsVue/'+this.action).then(response => {
            this.activisions = response.data
            this.activisions.forEach(el=>{
      this.data1.push(parseInt(el.count,10));
      console.log(this.data1);
      /*this.labels.push(el.name);*/
    });
 
});
           
            
          }
        ,
        formSubmit(e) {
                e.preventDefault();
                let currentObj = this;
                axios.post('http://127.0.0.1:8000/en/vueStatisticsPost/', {
                    action : { code: this.action } ,
                    year: this.year,
                    round: this.round,
                    id: this.id
                })
                .then(function (response) {
                    response.data= new Vue({ el: '#activity_Distautog' });
                    currentObj.output = response.data;
                })
                .catch(function (error) {
                    currentObj.output = error;
                });
    },
    mounted() {
          
        }

}
}

</script>