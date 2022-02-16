import { useState } from "react";

const SearchAria = (props) => {
    const [recordedProductNumber, setRecordedProductNumber] = useState('test');
    const [process, setProcess] = useState('3');

    const processOptions = props.processes.map(process => <option value={process.value}>{process.name}</option>);

    return(
        <section className="search-aria">
            <div className="search-box">
                <form className="form form--flex">
                    <div className="form__group">
                        <label className="form-label">製番</label>
                        <input type="text" className="form-input" name="recorded_product_number"
                        value={recordedProductNumber} onChange={(e) => setRecordedProductNumber(e.target.value)} />
                    </div>
                    <div className="form__group">
                        <label className="form-label">工程</label>
                        <select className="form-input form-input--select" name="process"
                        value={process} onChange={(e) => setProcess(e.target.value)}>
                            {processOptions}
                        </select>
                    </div>
                    <div className="form__group">
                        <button className="button">検索</button>
                    </div>
                </form>
            </div>
        </section>
    )
}

export default SearchAria;
