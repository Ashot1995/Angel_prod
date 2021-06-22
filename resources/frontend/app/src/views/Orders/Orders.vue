<template>
    <ContentWrapper>
        <div class="content-heading">
            <div>Dashboard
                <small>Welcome to Angle!</small>
            </div>
        </div>
        <div class="card card-default">
            <div class="card-header">Form</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <!-- Name input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="name">Имя</label>
                            <input  :class="{ 'is-invalid': submitted && $v.form.name.$error }" type="text" name="name" id="name" class="form-control" v-model="form.name"/>
                            <div v-if="submitted && $v.form.name.$error" class="invalid-feedback mb-2">
                                <span v-if="!$v.form.name.required">Имя обязательно</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- Phone input-->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="phone">Телефон</label>
                            <masked-input
                                :class="{ 'is-invalid': submitted && $v.form.phone.$error }"
                                :mask="['+', '7', ' ', '(', /[1-9]/, /\d/, /\d/, ')', ' ', /\d/, /\d/, /\d/, '-', /\d/, /\d/, /\d/, /\d/]"
                                v-model="form.phone"
                                class="form-control"
                                id="phone"/>
                            <div v-if="submitted && $v.form.phone.$error" class="invalid-feedback mb-2">
                                <span v-if="!$v.form.phone.required">Телефон обязательно</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <!-- Brand input-->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="brand">Марка</label>
                            <input :class="{ 'is-invalid': submitted && $v.form.brand.$error }" type="text" name="brand" id="brand" class="form-control" v-model="form.brand" />
                            <div v-if="submitted && $v.form.brand.$error" class="invalid-feedback mb-2">
                                <span v-if="!$v.form.brand.required">Марка обязательно</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- Model input-->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="model">Модель</label>
                            <input :class="{ 'is-invalid': submitted && $v.form.model.$error }" type="text" name="model" id="model" class="form-control" v-model="form.model"/>
                            <div v-if="submitted && $v.form.model.$error" class="invalid-feedback mb-2">
                                <span v-if="!$v.form.model.required">Модель обязательно</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-default">
            <div class="card-header row no-gutters align-items-center">
                <div class="col-auto m-0 h3">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="col">
                    <input name="location" ref="addressSearch"
                           class="form-control form-control-lg form-control-borderless pl-2"
                           v-model="search.address"
                           placeholder="Search topics or keywords"
                    />
                </div>
                <div class="col-auto">
                    <button class="btn btn-lg btn-info" type="button" @click="searchCompany">Поиск</button>
                </div>
            </div>
            <div class="card-body">
                <yandex-map v-bind="map">
                    <ymaps-marker v-for="(company, index) in companyList" v-bind="{...company, index}" @select="onSelect"/>
                </yandex-map>
            </div>
            <div class="card-footer">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-6">
                        <p v-if="book_info">
                            <b>{{ book_info.company.address }}</b>
                            <span class="text-info ml-1">{{book_info.date}} / {{book_info.time}}</span>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <fieldset>
                            <div class="form-group row">
                                <div class="col-md-10">
                                    <label class="c-radio">
                                        <input id="inlineradio1" type="radio" name="i-radio" :checked="!isChecked"/>
                                        <span class="fa fa-circle"></span> наличные</label>
                                    <label class="c-radio">
                                        <input id="inlineradio2" type="radio" name="i-radio" :checked="isChecked"/>
                                        <span class="fa fa-circle"></span> картой онлайн</label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-lg btn-info" @click="toOrder">Заказать</button>
                    </div>
                </div>
            </div>
        </div>
    </ContentWrapper>
</template>

<script>
import {mapActions} from 'vuex'
import 'vue-suggestions';
import MaskedInput from 'vue-text-mask';
import { required } from "vuelidate/lib/validators";


import $ from 'jquery';
import YandexMap from "@/components/Maps/YandexMap";
import YmapsMarker from "@/components/Maps/YmapsMarker";


export default {
    name: 'Orders',
    components: {
        YandexMap,
        YmapsMarker,
        MaskedInput,
    },
    data() {
        return {
            isChecked: true,
            search: {
                address: 'г Москва, Малый Кисловский пер, д 7',
            },

            submitted: false,
            map: {
                coords: [55.755829, 37.617627],
                zoom: 10
            },
            companyList: [],
            book_info: null,

            form: {
                name : '',
                phone: '',
                model: '',
                brand: '',
            }
        }
    },
    validations: {
        form: {
            name: { required },
            phone: { required },
            brand: { required },
            model: { required },
        }
    },
    mounted() {
        $(this.$refs.addressSearch).suggestions({
            token: "a1decd722774b7ea6c1f29ff6de5a9e258249368",
            type: "ADDRESS",
            onSelect({value}) {
                this.address = value;
            }
        });
    },
    created() {
        Promise.all([this.getCompanyList(), this.getCompanyById (4788)])
            .then(([response1, {data:{data}}]) => {
                this.companyList = [... response1.data, data];
            });
    },
    methods: {
        ... mapActions (['getCompanyList', 'getCompanyById', 'getAddressData', 'createOrder']),
        onSelect (index, result) {
            this.book_info = {
                ... result,
                company: this.companyList[index]
            }
        },
        searchCompany () {
            this.getAddressData(this.search).then((response) => {
                const {geo_lat, geo_lon} = response;
                if(!geo_lat || !geo_lon) return;

                const location = {x: geo_lat, y:geo_lon};
                console.log(location, 'Order.vue -line 146')

                let {index} = this.companyList.map((point, index) => ({ point: {
                        x: point.coordinate_lat,
                        y: point.coordinate_lon
                    }, index }))
                    .reduce((a, b) => this.distance(a.point, location) < this.distance(b.point, location) ? a : b);

                const {coordinate_lat, coordinate_lon} = this.companyList[index];
                this.map.coords = [coordinate_lat, coordinate_lon];
                this.map.zoom = 15;
            });

        },
        toOrder () {
            this.submitted = true;
            // stop here if form is invalid
            this.$v.$touch();
            if (this.$v.$invalid) {
                window.scrollTo(0,0)
                return;
            }

            const data = {
                ... this.form,
                company_id: this.book_info?.company_id,
                book_date : this.book_info?.date,
                book_time : this.book_info?.time
            };

            this.createOrder(data).then(response => {
                if(response?.data)
                    window.open(response.data.link)
            });
        },
        distance (a, b) {
            return Math.pow(a.x - b.x, 2) + Math.pow(a.y - b.y, 2);
        }
    }
}


</script>

<style lang="scss" scoped>
.form-control-borderless {
    border: none;
    &:hover, &:active, &:focus {
        border: none;
        outline: none;
        box-shadow: none;
    }
}
</style>

<style lang="scss">
.suggestions-wrapper {
    position: relative;
    z-index: 1;
    .suggestions-suggestions {
        background: white !important;
        border-radius: 25px;

        padding: 15px !important;
        left: 0 !important;
        > * {
            width: 320px;
            padding: 5px !important;
        }
    }
}
</style>
