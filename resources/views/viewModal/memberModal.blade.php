<!-- member Modal -->
<div class="portfolio-modal modal fade" id="memberModal" tabindex="-1" aria-labelledby="memberModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button></div>
            <div class="modal-body text-center pb-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <table class="table table-hover">
                            <tbody>
                                @foreach ($eventMember as $key => $member)
                                <tr>
                                    <td style="text-align: center;">{{$member['name']}}</td>
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