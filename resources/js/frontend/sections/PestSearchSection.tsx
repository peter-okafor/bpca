import { FC, HTMLAttributes, useState } from "react"
import { AtoZDescription, AtoZHeading, AtoZList, Input, InputGroup, ResetLink, SearchButton, Select } from "../components";
import { ComponentContentType, pestGroup } from "../data/models";

interface PestSearchSectionProps extends HTMLAttributes<HTMLElement> {
    description?: ComponentContentType;
    environments?: string[];
    pests?: pestGroup;
    search: (pest: string, environment: string, keyword: string, firstAlphabet: string) => void;
    reset: () => void
}

export const PestSearchSection: FC<PestSearchSectionProps> = ({
    className = '',
    description,
    environments = ['Both', 'Inside', 'Outside'],
    pests = [],
    search,
    reset,
    ...props
}) => {
    const [pest, setPest] = useState('');
    const [environment, setEnvironment] = useState('');
    const [keyword, setKeyword] = useState('');
    const [resetSelect, setResetSelect] = useState(false);
    const [selectedCharacter, setSelectedCharacter] = useState('');

    const submit = () => {
        search(pest, environment, keyword, selectedCharacter)
    }

    const resetParams = () => {
        setKeyword("");
        setPest("");
        setEnvironment("");
        setResetSelect(true);
        setSelectedCharacter("");
        reset();
    }

    return (
        <section
            className={`
                min-h-28
                h-fit
                w-full
                mb-8
                lg:mb-0
                bg-atoz 
                bg-no-repeat 
                bg-center 
                bg-cover 
                bg-origin-border 
                px-4
                lg:px-container_lg
                py-6
                lg:py-16
                ${className}
            `}
            {...props}
        >
            <div className={`
                grid
                grid-cols-1
                lg:grid-cols-2
                lg:mt-6
                gap-6
            `}>
                <AtoZHeading className="col-span-1">
                    A-Z of pests
                </AtoZHeading>
                <AtoZDescription className="col-span-1 hidden lg:block">
                    {description?.content}
                </AtoZDescription>
            </div>
            <div className={`
                grid
                grid-cols-1
                lg:grid-cols-4
                mt-6
                lg:mt-12
                gap-4
            `}>
                <InputGroup label="Pest type">
                    <Select
                        className="h-12 rounded-md border-0"
                        options={Object.values(pests).flat().map(p => p.name)}
                        placeholder="Any"
                        handleSelect={(pest) => setPest(pest)}
                        reset = {resetSelect}
                        setReset = {setResetSelect}
                    />
                </InputGroup>
                <InputGroup label="Environment">
                    <Select
                        className="h-12 rounded-md border-0"
                        options={environments}
                        placeholder="Any"
                        handleSelect={(pest) => setEnvironment(pest)}
                        reset = {resetSelect}
                        setReset = {setResetSelect}
                    />
                </InputGroup>
                <InputGroup label="Search by keyword">
                    <Input
                        className="h-12 rounded-md border-0"
                        value={keyword}
                        onChange={e => setKeyword(e.currentTarget.value)}
                    />
                </InputGroup>
                <SearchButton className="h-12 rounded-md border-0 mt-6" onClick={submit}/>
            </div>
            <div className={`
                grid
                grid-cols-1
                lg:grid-cols-2
                mt-4
                lg:mt-8
            `}>
                <AtoZList
                    selectedCharacter={selectedCharacter}
                    setSelectedCharacter={setSelectedCharacter}
                /> 
                <div className="text-right">
                    <ResetLink onClick={resetParams}/>
                </div>
            </div>
        </section>
    )
}


