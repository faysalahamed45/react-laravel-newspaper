function useTranslation({data, lang}) {
    const suffix = "_" + lang;

    function dataMapper(item, suffix) {
        for (const key in item) {
            if (key.includes(suffix)) {
                item[key.replace(suffix, "")] = item[key];
            }

            if (item[key] instanceof Object) {
                item[key] = useTranslation({data: item[key], lang});
            }
        }

        return item;
    }

    if (Array.isArray(data)) {
        return data.map(item => dataMapper(item, suffix));
    } else if (data instanceof Object) {
        return dataMapper(data, suffix);
    }

    return data;
}

export default useTranslation;
