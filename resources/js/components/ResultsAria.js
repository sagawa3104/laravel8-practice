import ResultRow from "./ResultRow";

const ResultsAria = (props) => {
    const resultRows = props.results.map((result,index) => <ResultRow key={index} result={result}></ResultRow>);
    return(
        <section className="result-aria">
            <div className="results-box">
                <table className="list-table">
                    <thead className="list-table__head">
                        <tr>
                            <th>製番</th>
                            <th>工程</th>
                            <th>方式</th>
                            <th>状態</th>
                            <th>検査</th>
                        </tr>
                    </thead>
                    <tbody className="list-table__body">
                        {resultRows}
                    </tbody>
                    <tfoot  className="list-table__foot"></tfoot>
                </table>
            </div>
        </section>
    )
}

export default ResultsAria;
