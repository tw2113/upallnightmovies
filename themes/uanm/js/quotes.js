(function () {
    const random = Math.floor(Math.random() * quotes.length);
    let container = document.querySelector('#quotecontainer');
    container.innerHTML = quotes[ random ];
})();