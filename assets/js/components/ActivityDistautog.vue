<template>
    <div id="activity-distautog" class="form-row">
        <div v-for="activity in activities" :key="activity.id">
        <label for="film_id">test</label>
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