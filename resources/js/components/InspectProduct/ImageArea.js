import PlotTableRow from "./PlotTableRow";

const ImageArea = (props) => {
    const inspection = props.inspection;
    const details = inspection? inspection.inspection_details:null;
    const rowRount = 20;
    const rows = [...Array(rowRount)].map((value, index) => (<PlotTableRow key={index} rowNum={index + 1} details={details} selectCell={props.selectCell} selectedCell={props.selectedCell} />) );
    return(
        <section className="image-area">
            <div className="left-block"></div>
            <div className="image-box">
                <img className="image-box__image" src="http://localhost/img/200x150.png" />
                <div className="image-box__plot-table">
                    {rows}
                </div>
            </div>
            <div className="right-block"></div>
        </section>
    )
}

export default ImageArea;
