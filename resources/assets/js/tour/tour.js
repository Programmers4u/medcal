var Tour = {
    steps: [],
    start: function() {
        var tour = new Tour({
            duration: 6500,
            delay: 1000,
            template: "@include('tour._template')",
            steps: steps
        });
        tour.init();
        tour.start();
    },
};