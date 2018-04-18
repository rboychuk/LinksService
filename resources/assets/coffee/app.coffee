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