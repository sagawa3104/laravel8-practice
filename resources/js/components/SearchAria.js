import { useEffect, useState } from "react";

const SearchAria = (props) => {
    const [recordedProductNumber, setRecordedProductNumber] = useState('test');
    const [process, setProcess] = useState(null);
    const [options, setOptions] = useState();

    const processes = props.processes;
    const setResults = props.setResults;
    useEffect(() => {
        const processOptions = processes? processes.map(process => (<option key={process.id} value={process.id}>{process.name}</option>)):null;
        console.log(processOptions);

        setOptions(processOptions);
    }, [processes]);

    const handleSubmit = (e) => {
        const fetchData = async () => {
            const res = await axios.get('api/inspections', {
                params:{
                    'recorded_number' : recordedProductNumber,
                    'process' : process,
                }
            });
            setResults(res.data);
        };

        e.preventDefault();
        fetchData();
    }

    return(
        <section className="search-aria">
            <div className="search-box">
                <form className="form form--flex" onSubmit={handleSubmit}>
                    <div className="form__group">
                        <label className="form-label">製番</label>
                        <input type="text" className="form-input" name="recorded_product_number"
                        value={recordedProductNumber} onChange={(e) => setRecordedProductNumber(e.target.value)} />
                    </div>
                    <div className="form__group">
                        <label className="form-label">工程</label>
                        <select className="form-input form-input--select" name="process"
                        value={process} onChange={(e) => setProcess(e.target.value)}>
                            <option key={0} value="">----</option>
                            {options}
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
