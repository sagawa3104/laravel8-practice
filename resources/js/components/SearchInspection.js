import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import ResultsAria from './ResultsArea';
import SearchAria from './SearchArea';

const SearchInspection = () => {

    const [processes, setProcesses] = useState([]);
    useEffect(() => {
        const fetchData = async () => {
            const res = await axios.get('api/processes');
            setProcesses(res.data);
        };
        fetchData();
    }, []);

    const [results, setResults] = useState();
    const fetchData = async (recordedProductNumber,process) => {
        const res = await axios.get('api/inspections', {
            params:{
                'recorded_number' : recordedProductNumber,
                'process' : process,
            }
        });
        setResults(res.data);
    }

    return(
        <div className="react-wrapper">
            <SearchAria processes={processes} fetchData={fetchData} />
            <ResultsAria results={results} />
        </div>
    )
}

export default SearchInspection;
// if (document.getElementById('app')) {
//     ReactDOM.render(<SearchInspection />, document.getElementById('app'));
// }
