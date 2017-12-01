require('../css/frontend-cms.scss');

var $ = require('jquery');
require('bootstrap-sass');
var MediumEditor = require('medium-editor');

var FetEditBtn = $('#FetEditBtn');
var FetSaveBtn = $('#FetSaveBtn');
var FetCancelBtn = $('#FetCancelBtn');
var FetEditable = false;
var FetEditor = null;

var FetToggleButtons = function () {
    if (FetEditable) {
        FetEditBtn.removeClass('hidden');
        FetSaveBtn.addClass('hidden');
        FetCancelBtn.addClass('hidden');
        FetEditor.destroy();
        FetEditable = false;
    } else {
        FetEditBtn.addClass('hidden');
        FetSaveBtn.removeClass('hidden');
        FetCancelBtn.removeClass('hidden');
        FetEditable = true;
    }
}

var FetHtml = function(html) {
    switch(html[0].tagName) {
        case 'IMG':
            return html.attr('src');
        default:
            return html.html();
    }
}

var FetSaveData = function(changes) {
    var dataPath = $('body').attr('data-frontend-editor-url');
    var type = $('body').attr('data-frontend-editor-type');
    $.ajax({
        type: 'POST',
        url: dataPath,
        data: {
            modifications: changes,
            type: type
        },
        success: function(data){

        }
    })
}

FetEditBtn.click(function(e) {
    if (FetEditor) {
        FetEditor.setup();
    } else {
        FetEditor = new MediumEditor('[data-fet]', {
            toolbar: {
                buttons: ['bold', 'italic', 'underline', 'anchor', 'h2', 'h3']
            }
        });
    }
    FetToggleButtons();
});
FetSaveBtn.click(function(e) {
    var changes = new Array();
    $('[data-fet]').filter(":visible").each(function() {
        $(this).attr('contenteditable', 'false');
        $(this).removeClass('editable');
        var key = $(this).attr('data-fet');
        var value = FetHtml($(this));
        changes.push({key: key, value: value.trim()});
    });
    FetSaveData(changes);
    FetToggleButtons();
});
FetCancelBtn.click(function(e) {
    $('[data-fet]').each(function(){
        $(this).attr('contenteditable', 'false');
        $(this).removeClass('editable');
    });
    FetToggleButtons();
});