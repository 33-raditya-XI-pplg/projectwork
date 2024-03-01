

let translatorSelector = "#language_translator_nav"
let flagSize = 24
if(windowSize.width <= 768)
{
    translatorSelector = "#language_translator_footer"
    flagSize = 32
}
window.gtranslateSettings = {
    "default_language": "id",
    "detect_browser_language": true,
    "languages": ["id","en","fr","de","it","es","ar"],
    "wrapper_selector": translatorSelector,
    "flag_size": flagSize
}
// console.log(gtranslateSettings)
let script = document.createElement('script');
script.src = url('vendor/gtranslate/popup.js');
script.defer = true
script.onload = function() {
};
document.body.append(script)


$(document).on('click','#navbar #navbar-search .search-icon', function(e){
    e.preventDefault();
    $('#navbar #navbar-search .search-content').toggleClass('show')
})

$(document).on('click','#navbar .btn-toggle-navbar-menu', function(e){
    e.preventDefault();
    $('#navbar .navbar-menu').toggleClass('show')
})
if(windowSize.width >= 1200)
{
    $(document).on('click','#navbar .menu-item .menu-link', function(e){
        e.preventDefault()
        $('#navbar .menu-item .sub-menu').slideUp(200)
        if($(this).parents('.menu-item').find('.sub-menu').length)
        {
            if($(this).parents('.menu-item').find('.sub-menu').css('display') == 'none')
            {
                $(this).parents('.menu-item').find('.sub-menu').slideDown(200)
            }else{
                $(this).parents('.menu-item').find('.sub-menu').slideUp(200)
            }
        }
    })

    $(document).on('click', function(event) {
		if (!event.target.matches('#navbar .menu-item .menu-link')) {
            $('#navbar .menu-item .sub-menu').slideUp(200)
        }
	});
}

function passwordInputRender(){
    let passwordInput = $('.input-password');

    if(passwordInput.length)
    {
        passwordInput.each(function(i,el){
            let _this = $(el)
            let _html = _this.html()
            let _label = $(_this.find('label')).get(0).outerHTML
            let _input = $(_this.find('input')).get(0).outerHTML
            let btnIds = randId(9)

            _this.removeClass('input-password')

            let replaceInput = `<div class="input-password">
                                ${_input}
                                <span class="input-password-eye-icon" __${btnIds}></span>
                            </div>`

            _this.find('input').replaceWith(replaceInput)

            $(document).on('click','[__'+btnIds+']', function(e){
                e.preventDefault()
                let inputPwd = $(this).parents('.input-password').find('input')

                if(inputPwd.attr('type') == 'password')
                {
                    inputPwd.attr('type','text')
                    $(this).addClass('show')
                }else{
                    inputPwd.attr('type','password')
                    $(this).removeClass('show')
                }

            })

        })
    }

}

passwordInputRender()