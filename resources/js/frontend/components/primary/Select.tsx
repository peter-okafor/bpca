import { FC, SelectHTMLAttributes, useEffect, useState } from "react";

interface SelectProps extends SelectHTMLAttributes<HTMLSelectElement> {
    options: string[];
    placeholder?: string;
    handleSelect: (v: string) => void;
    reset?: boolean;
    setReset?: React.Dispatch<React.SetStateAction<boolean>>
}

export const Select: FC<SelectProps> = ({
    options = [],
    placeholder,
    handleSelect,
    reset,
    setReset,
    ...props
}) => {
    const [val, setVal] = useState('');

    useEffect(() => {
        if (reset === true) {
            setVal('')
        }
    }, [reset]);

    const handleChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        let value = e.currentTarget.value;
        setVal(value);

        if (!!setReset) {
            setReset(false);
        }

        handleSelect(value !== placeholder ? value : '');
    };

    return (
        <select onChange={handleChange} {...props} value={val}>
            {placeholder && (
                <option>
                    {placeholder}
                </option>
            )}
            {options.map((option, i) => (
                <option key={i}>
                    {option}
                </option>
            ))}
        </select>
    )
}