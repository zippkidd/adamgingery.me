// (function() {
// 	'use strict';
// 	// Functions
// 	function main() {
// 		// Variables
// 		const constraints = {
// 	  	name: {
// 	  		presence: true,
// 	  	},
// 	    email: {
// 	      presence: true,
// 	      email: true
// 	    },
// 	    _subject: {
// 	    	presence: true,
// 	    },
// 	    message: {
// 	    	presence: true,
// 	    }
// 	  };

// 		// Selectors
// 		const formEl = document.querySelector('form');
// 		const inputs = formEl.querySelectorAll('input, textarea');
// 		const responseEl = document.querySelector('.responseMsg');

// 		// Event Listeners
// 		formEl.addEventListener('submit', handleSubmit);

// 		for (let i = 0; i < inputs.length; i++) {
// 			inputs[i].addEventListener('blur', function(){
// 				this.parentNode.classList.add('blurred');
// 				showErrors(inputs);
// 			});

// 			inputs[i].addEventListener('input', function(){
// 				showErrors(inputs);
// 			});
// 		}

// 		// Functions
// 		function clearErrors(inputs) {
// 			for (let i = 0; i < inputs.length; i++) {
// 				inputs[i].parentNode.classList.remove('show-error');
// 			}
// 		}

// 		function showErrors(inputs) {
// 			clearErrors(inputs);
// 			const errors = validate(formEl, constraints);
// 	    if (errors) {
// 	    	for (const prop in errors) {
// 		    	document.querySelector(`label[for="${prop}"]`).classList.add('show-error');
// 		    }
// 	    }
// 		}

// 		function initAjax(data, formEl, responseEl) {

// 			const ajax = new XMLHttpRequest();

// 			function processAjaxResponse() {
// 				if (ajax.readyState === XMLHttpRequest.DONE) {
// 					if (ajax.status === 200) {
// 						formEl.classList.add('hidden');
// 						responseEl.innerHTML = 'Thank you for contacting us, we\'ll get back to you soon.';
// 					} else {
// 						formEl.classList.add('hidden');
// 						responseEl.innerHTML = 'There was a problem with your form submission, please try again later.';
// 					}
// 				}
// 			}

// 			ajax.open('POST', 'https://formsubmit.co/ajax/CHANGEME', true);
// 			ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
// 			ajax.onreadystatechange = processAjaxResponse;
// 			ajax.send(data);
// 		}

// 		function handleSubmit(e) {
// 			e.preventDefault();
// 			const formData = new FormData(formEl);

// 	    for (let i = 0; i < inputs.length; i++) {
// 	    	if (!inputs[i].classList.contains('blurred')) {
// 	    		inputs[i].parentNode.classList.add('blurred');
// 	    	}
// 	    }

// 	    const errors = validate(formEl, constraints);

// 	    if (errors) {
// 	    	for (const prop in errors) {
// 		    	document.querySelector(`label[for="${prop}"]`).classList.add('show-error');
// 		    }
// 	    } else {
// 	    	initAjax(formData, formEl, responseEl);
// 	    }
// 		}
// 	}

// 	if (document.readyState === 'loading') {
// 		document.addEventListener('DOMContentLoaded', main);
// 	} else {
// 		main();
// 	}
// })();

// Transpiled below with Babel

(function () {
  'use strict'; // Functions

  function main() {
    // Variables
    var constraints = {
      name: {
        presence: true
      },
      email: {
        presence: true,
        email: true
      },
      _subject: {
        presence: true
      },
      message: {
        presence: true
      }
    }; // Selectors

    var formEl = document.querySelector('form');
    var inputs = formEl.querySelectorAll('input, textarea');
    var responseEl = document.querySelector('.responseMsg'); // Event Listeners

    formEl.addEventListener('submit', handleSubmit);

    for (var i = 0; i < inputs.length; i++) {
      inputs[i].addEventListener('blur', function () {
        this.parentNode.classList.add('blurred');
        showErrors(inputs);
      });
      inputs[i].addEventListener('input', function () {
        showErrors(inputs);
      });
    } // Functions


    function clearErrors(inputs) {
      for (var _i = 0; _i < inputs.length; _i++) {
        inputs[_i].parentNode.classList.remove('show-error');
      }
    }

    function showErrors(inputs) {
      clearErrors(inputs);
      var errors = validate(formEl, constraints);

      if (errors) {
        for (var prop in errors) {
          document.querySelector("label[for=\"".concat(prop, "\"]")).classList.add('show-error');
        }
      }
    }

    function initAjax(data, formEl, responseEl) {
      var ajax = new XMLHttpRequest();

      function processAjaxResponse() {
        if (ajax.readyState === XMLHttpRequest.DONE) {
          if (ajax.status === 200) {
            formEl.classList.add('hidden');
            responseEl.innerHTML = 'Thank you for contacting us, we\'ll get back to you soon.';
          } else {
            formEl.classList.add('hidden');
            responseEl.innerHTML = 'There was a problem with your form submission, please try again later.';
          }
        }
      }

      ajax.open('POST', 'https://formsubmit.co/ajax/CHANGEME', true);
//       ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      ajax.onreadystatechange = processAjaxResponse;
      ajax.send(data);
    }

    function handleSubmit(e) {
      e.preventDefault();
      var formData = new FormData(formEl);

      for (var _i2 = 0; _i2 < inputs.length; _i2++) {
        if (!inputs[_i2].classList.contains('blurred')) {
          inputs[_i2].parentNode.classList.add('blurred');
        }
      }

      var errors = validate(formEl, constraints);

      if (errors) {
        for (var prop in errors) {
          document.querySelector("label[for=\"".concat(prop, "\"]")).classList.add('show-error');
        }
      } else {
        initAjax(formData, formEl, responseEl);
      }
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', main);
  } else {
    main();
  }
})();