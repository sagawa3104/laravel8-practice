import { useParams } from 'react-router-dom';
import DetailArea from './DetailArea';
import ImageArea from './ImageArea';
import InfoArea from './InfoArea';

const InspectProduct = () => {
    const params = useParams()
    return(
        <div className="react-wrapper">
            <InfoArea inspectId={params.inspectId}/>
            <ImageArea />
            <DetailArea/>
        </div>
    )
}

export default InspectProduct;
