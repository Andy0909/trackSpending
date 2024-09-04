$(document).ready(function() {
    $('#addMember').click(function() {
        let newMemberEntry = `
            <div class="form-floating mb-3 d-flex align-items-center member-entry">
                <input class="form-control" name="member[]" type="text" placeholder="" required/>
                <label for="member">成員：</label>
                <button id="removeMember" type="button" class="btn btn-danger btn-circle btn-lg">-</button>
            </div>`;
        $('#memberContainer').append(newMemberEntry);
    });

    // Delegate event to dynamically added elements
    $('#memberContainer').on('click', '#removeMember', function() {
        $(this).closest('.member-entry').remove();
    });
});

$("#event").change(function() {
    $("#postEventId").submit();
});

function logout() {
    $("#logout").submit();
}

$('#socialLogin').click(function() {
    var isExpanded = $(this).attr('aria-expanded') === 'true';
    
    if (isExpanded) {
        $(this).attr('aria-expanded', 'false');
        $('#socialLoginCollapse').hide();
    } else {
        $(this).attr('aria-expanded', 'true');
        $('#socialLoginCollapse').show();
    }
});

function disableButton() {
    $('#submit').prop('disabled', true);
}

function disableUpdateButton() {
    $('#updateSubmit').prop('disabled', true);
}