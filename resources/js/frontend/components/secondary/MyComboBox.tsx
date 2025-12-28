import { Pest } from "@/frontend/data/models";
import { Combobox } from "@headlessui/react";
import { FC, useState } from "react";

interface MyComboBoxProps {
    options: any[];
    selected: string;
    className?: string;
    placeholder?: string;
    onSelected: (selected:string) => void;
}

export const MyComboBox: FC<MyComboBoxProps> = ({
    className,
    options,
    selected,
    placeholder,
    onSelected
}) => {
    const [query, setQuery] = useState('')

    const filteredServices =
        query === ''
            ? options
            : options.filter((service) => {
                return service.toLowerCase().includes(query.toLowerCase())
            })

    return (
        <div className={className}>
            <Combobox value={selected} onChange={onSelected}>
                <div className="relative">
                    <Combobox.Input
                        onChange={(event) => setQuery(event.target.value)}
                        className={`w-full px-4 py-2 text-sm leading-tight rounded-md text-gray-700 border appearance-none focus:outline-none border-none focus:ring-0 focus:shadow-xl h-10 disabled:bg-white disabled:opacity-90 disabled:text-black`}
                        placeholder={placeholder}
                    />
                    <Combobox.Options
                        className={
                            "overflow-y-auto w-full absolute rounded-md cursor-pointer mt-1 h-40 bg-white p-3 shadow-xl text-black"
                        }
                    >
                        {filteredServices &&
                            filteredServices.length > 0 &&
                            filteredServices.map((service, i) => (
                                <Combobox.Option
                                    className={`text-md py-1`}
                                    key={i}
                                    value={service}
                                >
                                    {service}
                                </Combobox.Option>
                            ))}
                    </Combobox.Options>
                </div>
            </Combobox>
        </div>
    );
}