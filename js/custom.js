
$(function(){

	/**
	 * assigning the last breadcrumb class to make it float right
	 */
    if ($('.client_app_breadcrumb li:last').find('.breadcrumbs-inner'))
    {
        $('.client_app_breadcrumb li:last').addClass('pull-right');
    }
});

/**
 * function used to show the loading message
 */
function showLoading()
{
    loadingMessage('show');
}

/**
 * function used to hide the loading message
 */
function hideLoading()
{
    loadingMessage('hide');
}

/**
 * function used to show/hide the loading message
 */
function loadingMessage(operation)
{
    if(!operation)
    {
        operation = 'show';
    }
    if (operation == 'show')
    {
        $(".go-loading").show();
    }
    else
    {
        $(".go-loading").hide();
    }
}

