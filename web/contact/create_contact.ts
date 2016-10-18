class AjaxSelect {

    public refresh(element, new_value = null) {
        $.ajax({
            url: $(element).data('url'),
            form_element: element,
            new_value: new_value,
            success: function (response) {
                var element = this.form_element;
                $(element).html('');
                $.each(response, function(i, d) {
                    $(element).append('<option value="' + d.id + '">' + d.text + '</option>');
                });
                $(element).selectpicker('refresh');
                if (this.new_value) {
                    $(element).val(this.new_value).trigger('change');
                }
            }
        });
    }

    
}

$(document).ready(function () {
    ajaxSelect2 = new AjaxSelect();
    
    $('.ajax-select').each(function(index, item) {
        ajaxSelect2.refresh(item);
    });

    $('.bootstrap-select').selectpicker({
        'dropupAuto': false
    });

    $('.ajaxForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (response) {
                ajaxSelect2.refresh($('#create_contact_titleId'), response.value);
                $('#myModal').modal('hide');
            }
        });
    });
});
