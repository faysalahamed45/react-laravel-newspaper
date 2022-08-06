const Spinner = ({spinner}) => {
    if (!spinner) {
        return <></>;
    }

    return (
        <div className="text-center p-4">
            <div className="spinner-border text-danger" role="status">
                <span className="visually-hidden">Loading...</span>
            </div>
        </div>
    );
};

export default Spinner;
