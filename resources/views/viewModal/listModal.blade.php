<!-- list Modal -->
<div class="portfolio-modal modal fade" id="listModal" tabindex="-1" aria-labelledby="listModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button></div>
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
                                </tr>
                              </thead>
                            <tbody>
                                <input type="hidden" id="spendListCount" value={{count($spendList)}}>
                                @foreach ($spendList as $key => $item)
                                    <input type="hidden" id="eventId" value={{$item['eventId']}}>
                                    <tr>
                                        <td id="itemName">{{$item['itemName']}}</td>
                                        <td>{{$item['price']}}</td>
                                        <td>{{$item['payer']}}</td>
                                        <td>{{implode('、', $item['shareMember'])}}</td>
                                        <td>
                                            <button type="button" id="editButton{{$key}}" class="btn btn-primary" data-toggle="modal" data-target="#popupModal" 
                                                    onclick="editRecord({{json_encode($item['itemId'])}}, {{json_encode($item['itemName'])}}, {{$item['price']}}, {{json_encode($item['payer'])}})">編輯
                                            </button>
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

<!-- popup Modal -->
@extends('viewModal/popup')

<script>
    function editRecord(itemId, itemName, price, payer) {
        setUpdateItemId(itemId);
        setUpdateItemName(itemName);
        setPopupTitle(itemName);
        setUpdatePrice(price);
        setUpdatePayer(payer);
        popupShow();
    }
</script>