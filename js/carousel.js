// (function() {
// 	'use strict';

// 	function main() {
// 		// Selectors
// 		const prev = document.querySelector('.carouselWrapper .prev');
// 		const next = document.querySelector('.carouselWrapper .next');

// 		// Variables
// 		const mySiema = new Siema({
// 			selector: '.carousel',
// 			duration: 750,
// 			loop: true,
// 			draggable: false,
// 		});

// 		// Functions
// 		let intervalId = window.setInterval(() => {
// 			mySiema.next();
// 		}, 4000);

// 		let reset = () => {
// 			window.clearInterval(intervalId);
// 			intervalId = window.setInterval(() => {
// 				mySiema.next();
// 			}, 4000);
// 		};

// 		// Event Listeners
// 		prev.addEventListener('click', () => {
// 			mySiema.prev(1);
// 			reset();
// 		});
// 		next.addEventListener('click', () => {
// 			mySiema.next(1);
// 			reset();
// 		});

// 	}
// 	if (document.readyState === 'loading') {
// 		document.addEventListener('DOMContentLoaded', main);
// 	} else {
// 		main();
// 	}
// })();

// Transpiled below with Babel

(function () {
  'use strict';

  function main() {
    // Selectors
    var prev = document.querySelector('.carouselWrapper .prev');
    var next = document.querySelector('.carouselWrapper .next'); // Variables

    var mySiema = new Siema({
      selector: '.carousel',
      duration: 750,
      loop: true,
      draggable: false
    }); // Functions

    var intervalId = window.setInterval(function () {
      mySiema.next();
    }, 4000);

    var reset = function reset() {
      window.clearInterval(intervalId);
      intervalId = window.setInterval(function () {
        mySiema.next();
      }, 4000);
    }; // Event Listeners


    prev.addEventListener('click', function () {
      mySiema.prev(1);
      reset();
    });
    next.addEventListener('click', function () {
      mySiema.next(1);
      reset();
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', main);
  } else {
    main();
  }
})();