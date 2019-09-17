/**
 * Created by Cherepanov on 10.09.2018.
 */

function updatePriceLabels() {
    //avoids slider overlap
    var sliders = document.querySelectorAll(".price-slider input");
    var val1 = parseInt(sliders[0].value);
    var val2 = parseInt(sliders[1].value);
    if (val1 >= val2) {
        sliders[0].value = val2 - 3;
        return;
    }
    if (val2 <= val1) {
        sliders[1].value = val1 + 3;
        return;
    }

    //adds color when a range is selected
    if (val1 > 0 || val2 < 99) {
        sliders[0].style.background = sliders[1].style.background = "-webkit-gradient(linear, 0 0,100% 0, color-stop(0, white), color-stop(" + (val1 / 100) + ", white),color-stop(" + (val1 / 100) + ", #f0f0f0), color-stop(" + (val2 / 100) + ", #f0f0f0), color-stop(" + (val2 / 100) + ", white))";
    } else {
        sliders[0].style.background = sliders[1].style.background = '';
    }
}


var ZS_filter;

ZS_filter = function () {

    this.parent = document.querySelector('[data-type="zs_ajax_range"]');
    this.firtsInput = this.parent.firstChild;
    this.lastInput = this.parent.lastChild;

    this.Init();
    this.Change();

    return this;

}
ZS_filter.prototype.Init = function(){

    this.firstValue = this.firtsInput.value;
    this.lastValue = this.lastInput.value;

    this.firstData = document.createElement('div');
    this.firstData.innerText = this.firstValue;
    this.firstData.classList.add('zs_filter_first_data');

    this.lastData = document.createElement('div');
    this.lastData.innerText = this.lastValue;
    this.lastData.classList.add('zs_filter_last_data');

    this.parent.appendChild(this.firstData);
    this.parent.appendChild(this.lastData);

    return this;
}
ZS_filter.prototype.Change = function () {

    var ZS = this;

    ZS_changeFirstObjectObject = this.firtsInput;

    ZS_changeLastObjectObject = this.lastInput;


    function ZS_changeFirstObjectObjectF(){

       ZS.firstData.innerText = ZS.firtsInput.value;

      return ZS;

    }


    function ZS_changeLastObjectObjectF(){

        ZS.lastData.innerText = ZS.lastInput.value;

        return ZS;

    }
    
    ZS_changeFirstObjectObject.addEventListener('change', ZS_changeFirstObjectObjectF, ZS, ZS_changeFirstObjectObject);

    ZS_changeLastObjectObject.addEventListener('change', ZS_changeLastObjectObjectF, ZS, ZS_changeLastObjectObject);

    return this;


}
// var e = new ZS_filter();

function zsHandleContacFormEvents($) {
	$('.w-dropdown').on('click', function(){
		var $customSelect = $(this);
		var $toggle = $customSelect.find('.w-dropdown-toggle');
		
		if($toggle.attr('aria-expanded') == 'true') {
			$customSelect.find('.w-dropdown-list').removeClass('w--open');		
			$toggle.removeClass('w--open');
			$toggle.removeAttr('aria-expanded');
			$customSelect.css('z-index', "");
		}
		else {
			$customSelect.find('.w-dropdown-list').addClass('w--open');		
			$toggle.addClass('w--open');
			$toggle.attr('aria-expanded', 'true');
			$customSelect.css('z-index', "901");
		}
	});
	
	
	$('.zs-contact-form .filter_drop.w-dropdown nav a').on('click', function(e){
		e.preventDefault();
		e.stopPropagation();
		
		var value = $(this).data('value');
		var $filterControl = $(this).closest('.zs-contact-form');
		var $select = $filterControl.find('select');
		$select.val(value);
		$select.trigger('change');
		
		var $customSelect = $(this).closest('.w-dropdown');
		$customSelect.find('.filter__placehoder-current').html($(this).html());
		
		$(this).parent().removeClass('w--open');
		var $toggle = $customSelect.find('.w-dropdown-toggle');
		$toggle.removeClass('w--open');
		$toggle.attr('aria-expanded', '');
		$customSelect.css('z-index', "");
	});	
}

jQuery(function($){
	// filter
	$('.filter__container .filter_drop.w-dropdown nav a').on('click', function(e){
		e.preventDefault();
		e.stopPropagation();
		
		var value = $(this).data('value');
		var $filterControl = $(this).closest('.filter__container');
		var $select = $filterControl.find('select');
		$select.val(value);
		$select.trigger('change');
		
		var $customSelect = $(this).closest('.w-dropdown');
		$customSelect.find('.filter__placehoder-current').html($(this).html());
		
		$(this).parent().removeClass('w--open');
		var $toggle = $customSelect.find('.w-dropdown-toggle');
		$toggle.removeClass('w--open');
		$toggle.attr('aria-expanded', '');
		$customSelect.css('z-index', "");
	});
	
	zsHandleContacFormEvents($);
});
