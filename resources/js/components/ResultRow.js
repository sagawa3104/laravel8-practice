const ResultRow = (props) => {
    return(
        <tr>
            <td>{props.result.recorded_product_number}</td>
            <td>{props.result.process_name}</td>
            <td>{props.result.form}</td>
            <td>{props.result.state}</td>
            <td>
                <a className="button" href="#">検査画面へ</a>
            </td>
        </tr>
    )
}

export default ResultRow;
