// (function() {
// 	'use strict';
// 	// Add scrolled class to body
// 	let last_known_scroll_position = 0;
// 	let ticking = false;

// 	function checkIsScrolled(scroll_pos) {
// 	  // Do something with the scroll position
// 	  if (scroll_pos > 5) {
// 	  	document.body.classList.add('scrolled');
// 	  } else {
// 	  	document.body.classList.remove('scrolled');
// 	  }
// 	}

// 	window.addEventListener('scroll', function(e) {
// 	  last_known_scroll_position = window.scrollY;

// 	  if (!ticking) {
// 	    window.requestAnimationFrame(function() {
// 	      checkIsScrolled(last_known_scroll_position);
// 	      ticking = false;
// 	    });

// 	    ticking = true;
// 	  }
// 	});

// 	let header = null;

// 	function domLoaded() {
// 		//== Variables
// 		const mobileHdrCTA = document.createElement('a');
// 		mobileHdrCTA.append('Enroll Today');
// 		mobileHdrCTA.classList.add('mobile-header-cta');
// 		mobileHdrCTA.href = '/contact-us/';
// 		//== Selectors
// 		header = document.getElementById('masthead');
// 		let menuItems = header.querySelectorAll('li a');

// 		//== Functions
// 		// Make Dead link menu items into span
// 		// menuItems = [...menuItems];
// 		// menuItems.forEach( link => {
// 		// 	if (link.getAttribute('href') === '#') {
// 		// 		link.outerHTML = `<span>${link.innerHTML}</span>`;
// 		// 	}
// 		// });
// 		for (let i = 0; i < menuItems.length; i++) {
// 			if (menuItems[i].getAttribute('href') === '#') {
// 				menuItems[i].outerHTML = `<span>${menuItems[i].innerHTML}</span>`;
// 			}
// 		}
// 		// Add Mobile CTA
// 		header.querySelector('.ast-site-identity').append(mobileHdrCTA);
// 	}

// 	function allLoaded() {
// 		//== Selectors
// 		const footer = document.querySelector('footer');
// 		const mainContent = document.getElementById('primary');
// 		const root = document.querySelector(':root');

// 		//== Variables
// 		const headerHeight = header.offsetHeight;
// 		const footerHeight = footer.offsetHeight;

// 		//== Functions
// 		// Fix margin top to keep page below menu
// 		// Set menuHeight as CSS variable
// 		root.style.setProperty('--headerHeight', `${headerHeight}px`);
// 		root.style.setProperty('--footerHeight', `${footerHeight}px`);
// 	}

// 	if (document.readyState === 'loading') {
// 		document.addEventListener('DOMContentLoaded', domLoaded);
// 	} else {
// 		domLoaded();
// 	}

// 	window.addEventListener('load', allLoaded);
// })();

// Transpiled below with Babel

(function () {
  'use strict';
  
  // Add scrolled class to body
  var last_known_scroll_position = 0;
  var ticking = false;

  function checkIsScrolled(scroll_pos) {
    // Do something with the scroll position
    if (scroll_pos > 5) {
      document.body.classList.add('scrolled');
    } else {
      document.body.classList.remove('scrolled');
    }
  }

  window.addEventListener('scroll', function (e) {
    last_known_scroll_position = window.scrollY;

    if (!ticking) {
      window.requestAnimationFrame(function () {
        checkIsScrolled(last_known_scroll_position);
        ticking = false;
      });
      ticking = true;
    }
  });
  var header = null;

  function domLoaded() {
    //== Variables
    header = document.getElementById('masthead');
    var menuItems = header.querySelectorAll('li a');
    
    //== Functions
    // Make Dead link menu items into span
    // menuItems = [...menuItems];
    // menuItems.forEach( link => {
    // 	if (link.getAttribute('href') === '#') {
    // 		link.outerHTML = `<span>${link.innerHTML}</span>`;
    // 	}
    // });
    for (var i = 0; i < menuItems.length; i++) {
      if (menuItems[i].getAttribute('href') === '#') {
        menuItems[i].outerHTML = "<span>".concat(menuItems[i].innerHTML, "</span>");
      }
    }

    // Add longtitle class to h1s over 30 characters
    if (document.querySelector('h1')) {
      var title = document.querySelector('h1');
      if (title.innerText.length > 30) {
        title.classList.add('longtitle');
      }
    }

    // if (document.querySelector('p') && document.querySelector('body:not(.disable-first-p)')) {
    //   document.querySelector('p').classList.add('first');
    // }

    // Add classes to leftover tiles in tiles grid
    if (document.querySelector('.tiles')) {
      var tileGrids = document.querySelectorAll('.tiles');
      for (var i = 0; i < tileGrids.length; i++) {
        var tiles = tileGrids[i].querySelectorAll('.wp-block-button');
        if (tiles.length % 3 === 2) { // give last two tiles .tile--double
          tiles[tiles.length - 1].classList.add('tile--double');
          tiles[tiles.length - 2].classList.add('tile--double');
        } else if (tiles.length % 3 === 1) { // give last tile .tile--single
          tiles[tiles.length - 1].classList.add('tile--single');
        }
      }
    }
  }

  function allLoaded() {
    //== Selectors
    var footer = document.querySelector('footer');
    var mainContent = document.getElementById('primary');
    var root = document.querySelector(':root'); //== Variables

    var headerHeight = header.offsetHeight;
    var footerHeight = footer.offsetHeight; //== Functions
    // Fix margin top to keep page below menu
    // Set menuHeight as CSS variable

    root.style.setProperty('--headerHeight', "".concat(headerHeight, "px"));
    root.style.setProperty('--footerHeight', "".concat(footerHeight, "px"));
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', domLoaded);
  } else {
    domLoaded();
  }

  window.addEventListener('load', allLoaded);
})();