<template>
    <div id="activity-distautog" class="form-row">
        <label for="film_id">tes lala</label>
        <div v-for="activity in activities" :key="activity.id">
        <label for="film_id">tes lala</label>
        <input id="film_id" >
        </div>
    </div>
</template>

<script>
export default {
    name: 'activity-distautog',
    props: {
        activities :[]
    },

}

</script>