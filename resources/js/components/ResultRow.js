const ResultRow = (props) => {
    return(
        <tr>
            <td>{props.result.recorded_product.recorded_number}</td>
            <td>{props.result.process.name}</td>
            <td>{props.result.recorded_product.product.name}</td>
            <td>{props.result.form}</td>
            <td>
                <a className="button" href="#">検査画面へ</a>
            </td>
        </tr>
    )
}

export default ResultRow;
