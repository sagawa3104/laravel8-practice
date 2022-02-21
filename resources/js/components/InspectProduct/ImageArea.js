import PlotTableRow from "./PlotTableRow";

const ImageArea = () => {
    const rowRount = 5;
    const rows = [...Array(rowRount)].map((value, index) => (<PlotTableRow key={index}></PlotTableRow>) );
    return(
        <section className="image-area">
            <div className="left-block"></div>
            <div className="image-box">
                <img className="image-box__image" src="http://localhost/img/200x150.png" />
                <table className="image-box__plot-table">
                    <tbody>
                        {rows}
                    </tbody>
                </table>
            </div>
            <div className="right-block"></div>
        </section>
    )
}

export default ImageArea;
