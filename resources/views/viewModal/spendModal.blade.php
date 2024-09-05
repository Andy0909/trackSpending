<!-- spend Modal -->
<div class="portfolio-modal modal fade" id="spendModal" tabindex="-1" aria-labelledby="spendModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button></div>
            <div class="modal-body text-center pb-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <table class="table table-hover">
                            <tbody style="text-align: center;">
                                @foreach ($averageResult as $payer => $item)
                                    @foreach ($item as $shareMember => $value)
                                        <tr>
                                            @if ($value < 0)
                                                <td>{{$payer}} 需付 {{$shareMember}} {{abs($value)}} 元</td>
                                            @else
                                                <td>{{$shareMember}} 需付 {{$payer}} {{$value}} 元</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>