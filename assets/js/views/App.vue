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
                    <option>DISTSELL</option>
                    
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
    <legend class="w-auto">Activities</legend>
     <div id='list' v-if='activities.length'>
         <div v-for='element in activities' >
            <div v-if='element.minNbActivities'>
         <table class='table'>
             <thead>
                <th>Id</th>
                <th>Activity Type</th>
                <th>Film</th>
                <th></th>
                    </thead> 
			
                <tr v-for="index in element.minNbActivities" :key="index">
                        <td><input class="form-control" type="text" v-model="element.id"></td>
                        <td><input class="form-control" type="text" v-model="element.activityType"></td>
                        <td><input class="form-control" type="text" ></td>
                        <td><a class="button is-primary">Add Movie</a></td>				
                
                </tr>
				
			
        </table>
        </div>
        </div>
	</div>
    <br>
    <div class="result"><a id="result_'" class="btn btn-success single_result" href="#" hidden></a></div>
    </fieldset>
    
    
    <button class="btn btn-primary col-lg-2 offset-md-1 shadow-lg mb-5 rounded">Save Project</button>
    <activity-distautog/>
</form> 
        <select name="LeaveType"  class="form-control" >
            <option value=" "></option>
            <option value="DISTAUTOG">DISTAUTOG</option>
            <option value="DEVSPFIC">DEVSPFIC</option>
        </select>
    <BarChart/>
    <br>
    {{ count }}
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
    name: 'app',
    components: {
      ActivityDistautog,
      BarChart,
    },
    data: () => ({
        activities: [],
        title:'test',
        action:"TEST",
        year: 2021,
        round: 1,
        output:'',
        id:0
    }),
     methods: {
        onChange(event) {
            axios.get('http://127.0.0.1:8000/en/handleActionVue/'+this.action).then(response => {
            this.activities = response.data
            this.title = activities[0].activity.value
            
          })
        },
        formSubmit(e) {
                e.preventDefault();
                let currentObj = this;
                axios.post('http://127.0.0.1:8000/en/vuePost/', {
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