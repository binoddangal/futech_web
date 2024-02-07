{{-- @dd(FunctionName) --}}
<script>
class DashboardDefault {
  constructor() {
    // References to page items that might require an update
    this._largeLineChart1 = null;
    this._largeLineChart1 = null;

    // Initialization of the page plugins
    this._initStatsCarousel();
    this._initVideoGuidePlayer();
    this._initHelpSelect2();
    this._initTour();

    // Template specific event listeners
    this._initEvents();
  }

  _initEvents() {
    // Listening for color change events to update charts
    document.documentElement.addEventListener(Globals.colorAttributeChange, (event) => {
      this._largeLineChart1 && this._largeLineChart1.destroy();
      this._largeLineChart2 && this._largeLineChart2.destroy();
      this._initSalesStocksCharts();
    });
  }

  // Stats Carousel
  _initStatsCarousel() {
    if (document.querySelector('#statsCarousel') !== null && typeof GlideCustom !== 'undefined') {
      new GlideCustom(
        document.querySelector('#statsCarousel'),
        {
          gap: 0,
          rewind: false,
          bound: true,
          perView: 6,
          breakpoints: {
            400: {perView: 1},
            600: {perView: 2},
            1400: {perView: 3},
            1600: {perView: 4},
            1900: {perView: 5},
            3840: {perView: 6},
          },
        },
        true,
      ).mount();
    }
  }

  // Video Guide Player
  _initVideoGuidePlayer() {
    if (document.querySelector('#videoGuide') !== null && typeof Plyr !== 'undefined') {
      new Plyr(document.querySelector('#videoGuide'));
    }
  }

  // Help Category Select2
  _initHelpSelect2() {
    if (jQuery().select2) {
      jQuery('#categorySelect').select2({minimumResultsForSearch: Infinity});
    }
  }
  // Dashboard Take a Tour
  _initTour() {
    if (typeof introJs !== 'undefined' && document.getElementById('dashboardTourButton') !== null) {
      document.getElementById('dashboardTourButton').addEventListener('click', (event) => {
        introJs()
          .setOption('nextLabel', '<span>Next</span><i class="cs-chevron-right"></i>')
          .setOption('prevLabel', '<i class="cs-chevron-left"></i><span>Prev</span>')
          .setOption('skipLabel', '<i class="cs-close"></i>')
          .setOption('doneLabel', '<i class="cs-check"></i><span>Done</span>')
          .setOption('overlayOpacity', 0.5)
          .start();
      });
    }
  }
}

</script>
