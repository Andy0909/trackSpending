<!-- resources/views/viewModal/popup.blade.php -->
<div class="modal fade" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="popupModalTitle">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="popupModalTitle"></h5>
            </div>
            <div class="modal-body" id="popupModalContent">
                <form action="/updateItem" method="POST" onsubmit="disableUpdateButton()">
                    @csrf
                    <input type="hidden" id="eventId" name="eventId" value={{$eventId}}>
                    <input type="hidden" id="itemId" name="itemId">
                    <input type="hidden" id="updateItem" name="updateItem">

                    <!-- price input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="updatePrice" name="updatePrice" type="number" min="1" placeholder="Enter price..." required/>
                        <label for="updatePrice">金額：</label>
                    </div>
                    
                    <!-- payer input-->
                    <div class="form-floating mb-3" style="padding-bottom: 10%">
                        <label id="payerLable" for="updatePayer">付錢者：</label>
                    </div>
                    <select class="form-select" id="updatePayer" name="updatePayer" required>
                        @foreach ($eventMember as $member)
                            <option value="{{ $member['id'] }}">{{ $member['name'] }}</option>
                        @endforeach
                    </select>

                    <!-- average input-->
                    <div class="form-floating mb-3" style="padding-bottom: 10%">
                        <label id="averageLable" for="updateAverage">分攤者：</label>
                    </div>
                    <select class="selectpicker" id="updateAverage" name="updateAverage[]"  multiple>
                        @foreach ($eventMember as $member)
                            <option value="{{ $member['id'] }}">{{ $member['name'] }}</option>
                        @endforeach
                    </select>

                    <div class="modal-footer" style="margin-top: 10%">
                        <center>
                            <button type="submit" id="updateSubmit" class="btn btn-primary" data-dismiss="modal">更新</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="popupClose()">取消</button>
                        </center>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jquery.js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- popup.js -->
<script src="{{ asset('js/popup.js') }}"></script>
<script src="{{ asset('js/trackSpending.js') }}"></script>

<script>
    new MultiSelectTag('updateAverage')  //id
</script>

