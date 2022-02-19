import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import ResultsAria from './ResultsAria';
import SearchAria from './SearchAria';

const InspectionSearch = () => {

    const [processes, setProcesses] = useState();
    useEffect(() => {
        const fetchData = async () => {
            const res = await axios.get('api/processes');
            setProcesses(res.data);
        };
        fetchData();
    }, []);

    const [results, setResults] = useState();


    return(
        <div className="react-wrapper">
            <SearchAria processes={processes} setResults={setResults} />
            <ResultsAria results={results} />
        </div>
    )
}

if (document.getElementById('app')) {
    ReactDOM.render(<InspectionSearch />, document.getElementById('app'));
}
