<!-- List Modal -->
<div class="portfolio-modal modal fade" id="listModal" tabindex="-1" aria-labelledby="listModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pb-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <table class="table table-hover" id="listTable">
                            <thead>
                                <tr>
                                    <th scope="col">項目</th>
                                    <th scope="col">價錢</th>
                                    <th scope="col">支付者</th>
                                    <th scope="col">平分者</th>
                                    <th scope="col">編輯</th>
                                    <th scope="col">刪除</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($formattedItems as $key => $item)
                                    <tr data-event-id="{{ $item['eventId'] }}">
                                        <td>{{ $item['itemName'] }}</td>
                                        <td>{{ $item['price'] }}</td>
                                        <td>{{ $item['payer'] }}</td>
                                        <td>{{ implode('、', $item['shareMember']) }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#popupModal" 
                                                data-item='@json($item)' onclick="editRecord(this)">編輯
                                            </button>
                                        </td>
                                        <td>
                                            <form action="/deleteItem" method="POST">
                                                @csrf
                                                <input type="hidden" id="eventId" name="eventId" value="{{ $item['eventId'] }}">
                                                <input type="hidden" id="itemId" name="itemId" value="{{ $item['itemId'] }}">
                                                <button type="submit" id="deleteSubmit" class="btn btn-danger">刪除</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popup Modal -->
@extends('viewModal/popup')

<script>
    function editRecord(button) {
        var item = JSON.parse(button.getAttribute('data-item'));
        setUpdateItemId(item.itemId);
        setUpdateItemName(item.itemName);
        setPopupTitle(item.itemName);
        setUpdatePrice(item.price);
        setUpdatePayer(item.payer);
        popupShow();
    }
</script>