<div class="tab-pane" id="checkout_early">
    <div>
        <table id="checkoutEarlyTable" class="display">
            <thead style="border: 1px; border: radius 30px; background:#0000ff; color:#fff;">
                <tr>
                    <th style="text-align:center">Num</th>
                    <th style="text-align:center">Date</th>
                    <th style="text-align:center">Time checked out</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        var table = $('#checkoutEarlyTable').DataTable();

        $('#customLength').on('change', function() {
            var length = $(this).val();
            table.page.len(length).draw();
        });

        $('#customSearch').on('keyup', function() {
            table.search($(this).val()).draw();
        });
    });
</script>