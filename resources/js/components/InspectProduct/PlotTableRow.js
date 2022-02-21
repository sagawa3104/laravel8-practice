import PlotTableCell from "./PlotTableCell";

const PlotTableRow = () => {
    const cellCount = 5;
    const cells = [...Array(cellCount)].map((value, index) => (<PlotTableCell key={index}></PlotTableCell>) );
    return(
        <tr>
            {cells}
        </tr>
    )
}

export default PlotTableRow;
