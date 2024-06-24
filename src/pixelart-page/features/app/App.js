import { ErrorBoundary } from "react-error-boundary";
import { Alert, Button, Card, Col, Row, Space } from 'antd';
import Grid from "../grid/Grid";
import ColorPicker from "../grid/ColorPicker";
import { fetchPixelData, resetPixels, savePixelData } from "../grid/gridSlice";
import { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";

const App = () => {
	const dispatch = useDispatch();

	const { pixelData, savedPixelData, isPixelDataFetching, isPixelDataSaving, alert } = useSelector((state) => state.grid);
	const buttonDisabled = (isPixelDataFetching || JSON.stringify(pixelData) === JSON.stringify(savedPixelData)) ? true : false;

	useEffect(() => {
		dispatch(fetchPixelData())
	}, [])

	const handlePixelDataReset = () => {
		dispatch(resetPixels());
	}

	const handlePixelDataSave = () => {
		dispatch(savePixelData({data:pixelData}));
	}

	return (
		<div className="wrap">
			<h1 style={{ fontFamily: 'Trebuchet MS',fontWeight:500, fontSize: '35px', marginBottom: '15px' }}><span style={{ color: '#ffb61a' }}>WP Plugin</span><span style={{ color: '#674399' }}> Boilerplate</span></h1>
			<ErrorBoundary fallback={<div>Something went wrong</div>}>
				<Card>
					<Row justify="center">
						<Col>
							<Grid />
						</Col>
					</Row>
					<Row justify="center">
						<Col>
							<ColorPicker />
						</Col>
					</Row>
					<Row justify="center">
						<Col>
							<Space size="middle">
								<Button type="default" disabled={isPixelDataFetching} onClick={handlePixelDataReset}>Reset</Button>
								<Button type="primary" disabled={buttonDisabled} loading={isPixelDataSaving} onClick={handlePixelDataSave}>Save</Button>
							</Space>
						</Col>
					</Row>
					{alert.type && alert.message &&
						<Row justify="center">
							<div direction="vertical" size="middle" style={{ marginTop: '20px' }}>
								<Alert message={alert.message} type={alert.type} closable={true}/>
							</div>
						</Row>
					}
				</Card>
			</ErrorBoundary>
		</div>
	)
}

export default App;