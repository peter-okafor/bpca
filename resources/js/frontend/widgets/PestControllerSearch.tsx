import { Inertia } from "@inertiajs/inertia";
import { FC, HtmlHTMLAttributes, useState } from "react";
import { Input } from "../components/primary/Input";
import { SearchButton } from "../components/primary/SearchButton";
import { WidgetHeading } from "../components/primary/WidgetHeading";
import { InputGroup } from "../components/secondary/InputGroup";

interface PestControllerSearchProps extends HtmlHTMLAttributes<HTMLDivElement> {
    pestName: string;
    pestCode: string;
}

export const PestControllerSearch: FC<PestControllerSearchProps> = ({
    pestName,
    pestCode,
    className,
    ...props
}) => {
    const [postcode, setPostcode] = useState('');

    const submit = () => {
        if (pestCode && postcode) {
            // Inertia.visit(`/pest-controllers`, {
            //     data: {
            //         pest: pestCode,
            //         postcode: postcode
            //     }
            // })

            window.location.href = `/pest-controllers?pest=${pestCode}&postcode=${postcode}`;
        }
    }
    
    return (
        <div
            className={`${className} px-3 rounded-md pt-3 bg-gradient-to-r from-[#7035D5] to-[#CF3259]`}
            {...props}
        >
            <div className="w-full h-full px-4 pt-9 pb-9 rounded-md bg-location bg-no-repeat bg-right-top bg-[percentage:33%] bg-origin-padding">
                <WidgetHeading className="pr-10">
                    Find pest controllers in your area that deal with {pestName}
                </WidgetHeading>
                <InputGroup label="Enter Postcode">
                    <Input value={postcode} onChange={e => setPostcode(e.currentTarget.value)} />
                </InputGroup>
                <SearchButton className="h-12 rounded-md border-0 mt-6 w-full" onClick={submit}/>
            </div>
        </div>
    );
}