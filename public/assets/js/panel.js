
$('[data-toggle="sidebar"]').each(function(i,el){
    setEventToggleSidebar(el)
})

function setEventToggleSidebar(el){
    $(el).removeAttr('data-toggle')
    $(el).on('click', function(e){
        e.preventDefault();
        $('#panel-sidebar').toggleClass('expanded')
        $('#panel-navbar').toggleClass('expanded')
        $('#panel-content').toggleClass('expanded')
    })
}

var windowWidth = $(window).width();
if(windowWidth > 992){
    $('#panel-sidebar').addClass('expanded')
    $('#panel-navbar').removeClass('expanded')
    $('#panel-content').removeClass('expanded')
}else{
    $('#panel-sidebar').removeClass('expanded')
    $('#panel-navbar').addClass('expanded')
    $('#panel-content').addClass('expanded')
}

$(window).resize(function(){
    var windowWidth = $(window).width();
    if(windowWidth > 992){
        $('#panel-sidebar').addClass('expanded')
        $('#panel-navbar').removeClass('expanded')
        $('#panel-content').removeClass('expanded')
    }else{
        $('#panel-sidebar').removeClass('expanded')
        $('#panel-navbar').addClass('expanded')
        $('#panel-content').addClass('expanded')
    }
})

$('.nav-dropdown').each(function(i,el){
    $(el).find('.nav-dropdown-content').css({
        display: 'none'
    })
    // setEventToggleSidebar(el)
})

$(document).on('click','.nav-dropdown .nav-dropdown-btn', function(e){
    e.preventDefault()
    // $('.nav-dropdown .nav-dropdown-content').css('display','none')
    if($(this).parents('.nav-dropdown').find('.nav-dropdown-content').css('display') == 'none')
    {
        $(this).parents('.nav-dropdown').find('.nav-dropdown-content').slideDown(200)
    }else{
        $(this).parents('.nav-dropdown').find('.nav-dropdown-content').slideUp(200)
    }
})

$('#panel-sidebar .sub-menu-content').each(function(i,el){
    let dropdownParent = $(el).parents('.sidebar-menu-item')
    let btnLink = dropdownParent.find('.item-link')
    dropdownParent.addClass('dropdown')
    btnLink.on('click',function(e){
        e.preventDefault()
        dropdownParent.toggleClass('active')
    })
})

var FileUploadCustom = {
    primary: '#FD7702',
    secondary: '#005267',
    background: '#fff',
    tertiary: '#FD7702'
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

$(document).on('focus','.input-group .form-control', function(){
    $(this).parent().find('.input-group-text').addClass('focused')
})

$(document).on('blur','.input-group .form-control', function(){
    $(this).parent().find('.input-group-text').removeClass('focused')
})