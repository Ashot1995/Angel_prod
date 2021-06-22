<template>
    <div>
        <ymap-marker
            :coords="[coordinate_lat,coordinate_lon]"
            :marker-id="id"

            cluster-name="companies"
            marker-type="placemark"

            @click="showModal"
        ></ymap-marker>
        <b-modal ref="modal" hide-header @ok="onSelect">
            <div class="row">
                <div class="col-auto text-center w-100">
                        <h5><strong>Компания</strong> : {{ title }}</h5>
                        <p><strong>Адрес</strong> : {{ address }}</p>
                        <p><strong>Телефон</strong> : {{ phone }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="book_date">Выберите дату бронирования</label>
                    <select id="book_date" class="form-control" :disabled="!dateOptions.length" v-model="form_date">
                        <option v-for="date in dateOptions" :value="date">
                            {{ date }}
                        </option>
                    </select>
                </div>
                <div class="col-6">
                    <label for="book_time">Выберите бронирования время</label>
                    <select id="book_time" class="form-control" :disabled="!timeOptions.length" v-model="form_time">
                        <option v-for="time in timeOptions.map(({time}) => time)" :value="time">
                            {{ time }}
                        </option>
                    </select>
                </div>
            </div>
        </b-modal>
    </div>
</template>

<script>
import {ymapMarker} from "vue-yandex-maps";
import {mapActions} from 'vuex';

export default {
    name: "YmapsMarker",
    props: [
        'coordinate_lat',
        'coordinate_lon',
        'index',
        'title',
        'address',
        'phone',
        'id'
    ],
    data () {
        return  {
            dateOptions: [],
            timeOptions: [],

            form_date:null,
            form_time: null,

            selectedTarget: null,
            target: null,
        }
    },
    watch: {
        form_date (date)  {
            this.form_date = date;
            this.getCompanyBookTime ({companyId:this.id, date}).then(response => {
                this.timeOptions = response.data || [];
            });
        }
    },
    components:{
        'ymap-marker':ymapMarker,
    },
    methods: {
        ... mapActions(['getCompanyBookDate', 'getCompanyBookTime']),
        showModal (e) {
            this.target = e.get('target');

            this.getCompanyBookDate(this.id).then(response => {
                this.dateOptions = response.data.booking_dates;
            });

            this.$refs['modal'].show();
        },
        onSelect () {
            const {id ,form_date, form_time} = this;
            if ([!form_time, !form_date].includes(true))return ;

            if(this.selectedTarget) this.selectedTarget.options.set('iconColor', "#2695f9");
            this.target.options.set('iconColor', 'red');

            this.$emit('select', this.index, {
                company_id: id,
                date: form_date,
                time: form_time
            });
            window.scrollTo(0,document.body.scrollHeight);
        }
    }
}
</script>

<style scoped>

</style>
