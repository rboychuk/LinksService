$('#sel1').on 'change', ->
    value = $(this).val()
    if value != 0
        location.href = '/links/' + value


$('#sel2').on 'change', ->
    value = $(this).val()
    if value != 0
        location.href = '/report/' + value


updateTable: (value) ->
    data =
        url: 'table'
        value: value

    @send data
    return true

send: (data, callback) ->
    $.ajax(
        type: 'POST'
        url: url + '/' + data.action
        data: data
    )
        .done(callback ?= ->)
    return

if($('#multidomain').val() > 0 && !$('#multidomain').is(':checked'))
    $('#add_link').hide()

$('#multidomain').on 'change', ->
    if($('#multidomain').is(':checked'))
        $('#add_link').show()
    else
        $('#add_link').hide()