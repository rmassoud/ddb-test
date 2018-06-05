var regionsSelect = document.getElementById("regions");
var currentRegion = regionsSelect.options[regionsSelect.selectedIndex].value;

var areasSelect = document.getElementById("areas");
var currentArea = areasSelect.options[areasSelect.selectedIndex].value;

var app = new Vue({
    el: '#app',
    delimiters: ["${", "}"],
    data: {
        products: [],
        currentRegion: currentRegion,
        currentArea: currentArea,
        currentPage: 1,
        results: 0,
    },
    mounted() {
        this.search();

    },
    computed: {
        numberOfPages () {
            return Math.ceil(this.results / 25);
        },
    },
    watch: {
        currentPage () {
            this.search();
        }
    },
    methods: {
        filterChange() {
          this.currentPage = 1;
          this.search();
        },
        search() {
            let url = '/search-data?rg=' + this.currentRegion + '&ar=' + this.currentArea + '&page=' + this.currentPage;
            axios.get(url).then((response) => {
                this.products = response.data.products;
                this.results = response.data.numberOfResults;
                console.log(response.data);
            }).catch( error => { console.log(error); });

        }

    },
});

