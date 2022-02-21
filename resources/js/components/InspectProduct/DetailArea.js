const DetailArea = () => {

    return(
        <section class="detail-area">
            <div class="result-details-box">
                <table class="list-table">
                    <thead class="list-table__head">
                        <tr>
                            <th>カラム1</th>
                            <th>カラム2</th>
                            <th>カラム3</th>
                        </tr>
                    </thead>
                    <tbody class="list-table__body">
                        <tr>
                            <td>value1</td>
                            <td>value2</td>
                            <td>value3</td>
                        </tr>
                        <tr>
                            <td>value1</td>
                            <td>value2</td>
                            <td>value3</td>
                        </tr>
                        <tr>
                            <td>value1</td>
                            <td>value2</td>
                            <td>value3</td>
                        </tr>
                    </tbody>
                    <tfoot class="list-table__foot">
                    </tfoot>
                </table>
            </div>
        </section>
    )
}

export default DetailArea;
