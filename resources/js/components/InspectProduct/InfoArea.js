import PreviousMap from "postcss/lib/previous-map";

const InfoArea = (props) => {

    return(
        <section class="info-area">
            <p>情報エリア:検査ID{props.inspectId}</p>
        </section>
    )
}

export default InfoArea;
